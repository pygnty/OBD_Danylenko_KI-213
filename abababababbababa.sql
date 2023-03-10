PGDMP     $    0                z            MDB    12.7    12.7 #    2           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            3           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            4           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            5           1262    32856    MDB    DATABASE     ?   CREATE DATABASE "MDB" WITH TEMPLATE = template0 ENCODING = 'UTF8' LC_COLLATE = 'Russian_Russia.1251' LC_CTYPE = 'Russian_Russia.1251';
    DROP DATABASE "MDB";
                postgres    false                        3079    32889 	   uuid-ossp 	   EXTENSION     ?   CREATE EXTENSION IF NOT EXISTS "uuid-ossp" WITH SCHEMA public;
    DROP EXTENSION "uuid-ossp";
                   false            6           0    0    EXTENSION "uuid-ossp"    COMMENT     W   COMMENT ON EXTENSION "uuid-ossp" IS 'generate universally unique identifiers (UUIDs)';
                        false    2            ?            1255    32977     transaction_balance_adjustment()    FUNCTION     6  CREATE FUNCTION public.transaction_balance_adjustment() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
	UPDATE clients SET balance = balance - NEW.amount WHERE id= NEW.sender_id; 
	UPDATE clients SET balance = balance + NEW.amount WHERE id= NEW.recipient_id; 
   -- trigger logic
   return NEW;
END;
$$;
 7   DROP FUNCTION public.transaction_balance_adjustment();
       public          postgres    false            ?            1259    32911    clients    TABLE     ?   CREATE TABLE public.clients (
    id integer NOT NULL,
    name character varying(255) NOT NULL,
    balance numeric(10,2) DEFAULT 0 NOT NULL,
    worker_id integer,
    registered time with time zone DEFAULT now() NOT NULL
);
    DROP TABLE public.clients;
       public         heap    postgres    false            7           0    0 
   TABLE clients    ACL     ?   GRANT ALL ON TABLE public.clients TO db_admin;
GRANT ALL ON TABLE public.clients TO db_full_admin;
GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE public.clients TO global_admin;
GRANT SELECT ON TABLE public.clients TO userok;
          public          postgres    false    209            ?            1259    32909    clients_id_seq    SEQUENCE     ?   CREATE SEQUENCE public.clients_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE public.clients_id_seq;
       public          postgres    false    209            8           0    0    clients_id_seq    SEQUENCE OWNED BY     A   ALTER SEQUENCE public.clients_id_seq OWNED BY public.clients.id;
          public          postgres    false    208            ?            1259    32859 	   filiation    TABLE     }   CREATE TABLE public.filiation (
    id integer NOT NULL,
    address character varying(255) NOT NULL,
    boss_id integer
);
    DROP TABLE public.filiation;
       public         heap    postgres    false            9           0    0    TABLE filiation    ACL     ?   GRANT ALL ON TABLE public.filiation TO db_admin;
GRANT ALL ON TABLE public.filiation TO db_full_admin;
GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE public.filiation TO global_admin;
          public          postgres    false    204            ?            1259    32857    filiation_id_seq    SEQUENCE     ?   CREATE SEQUENCE public.filiation_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 '   DROP SEQUENCE public.filiation_id_seq;
       public          postgres    false    204            :           0    0    filiation_id_seq    SEQUENCE OWNED BY     E   ALTER SEQUENCE public.filiation_id_seq OWNED BY public.filiation.id;
          public          postgres    false    203            ?            1259    32903    transactions    TABLE     !  CREATE TABLE public.transactions (
    amount double precision NOT NULL,
    recipient_id integer NOT NULL,
    sender_id integer NOT NULL,
    id uuid DEFAULT public.uuid_generate_v4() NOT NULL,
    comment character varying(255),
    "time" time with time zone DEFAULT now() NOT NULL
);
     DROP TABLE public.transactions;
       public         heap    postgres    false    2            ;           0    0    TABLE transactions    ACL     ?   GRANT ALL ON TABLE public.transactions TO db_admin;
GRANT ALL ON TABLE public.transactions TO db_full_admin;
GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE public.transactions TO global_admin;
          public          postgres    false    207            ?            1259    32867    workers    TABLE     @  CREATE TABLE public.workers (
    id integer NOT NULL,
    name character varying(255) NOT NULL,
    "position" character varying(255) NOT NULL,
    sallary real NOT NULL,
    boss_id integer,
    filiation_id integer NOT NULL,
    login character varying(50),
    password character varying(256),
    rights integer
);
    DROP TABLE public.workers;
       public         heap    postgres    false            <           0    0 
   TABLE workers    ACL     ?   GRANT ALL ON TABLE public.workers TO db_admin;
GRANT ALL ON TABLE public.workers TO db_full_admin;
GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE public.workers TO global_admin;
GRANT SELECT,INSERT,UPDATE ON TABLE public.workers TO table_admin;
          public          postgres    false    206            ?            1259    32865    workers_id_seq    SEQUENCE     ?   CREATE SEQUENCE public.workers_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE public.workers_id_seq;
       public          postgres    false    206            =           0    0    workers_id_seq    SEQUENCE OWNED BY     A   ALTER SEQUENCE public.workers_id_seq OWNED BY public.workers.id;
          public          postgres    false    205            ?
           2604    32914 
   clients id    DEFAULT     h   ALTER TABLE ONLY public.clients ALTER COLUMN id SET DEFAULT nextval('public.clients_id_seq'::regclass);
 9   ALTER TABLE public.clients ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    208    209    209            ?
           2604    32862    filiation id    DEFAULT     l   ALTER TABLE ONLY public.filiation ALTER COLUMN id SET DEFAULT nextval('public.filiation_id_seq'::regclass);
 ;   ALTER TABLE public.filiation ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    203    204    204            ?
           2604    32870 
   workers id    DEFAULT     h   ALTER TABLE ONLY public.workers ALTER COLUMN id SET DEFAULT nextval('public.workers_id_seq'::regclass);
 9   ALTER TABLE public.workers ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    206    205    206            ?
           2606    32921    clients clients_pkey 
   CONSTRAINT     R   ALTER TABLE ONLY public.clients
    ADD CONSTRAINT clients_pkey PRIMARY KEY (id);
 >   ALTER TABLE ONLY public.clients DROP CONSTRAINT clients_pkey;
       public            postgres    false    209            ?
           2606    32864    filiation filiation_pkey 
   CONSTRAINT     V   ALTER TABLE ONLY public.filiation
    ADD CONSTRAINT filiation_pkey PRIMARY KEY (id);
 B   ALTER TABLE ONLY public.filiation DROP CONSTRAINT filiation_pkey;
       public            postgres    false    204            ?
           2606    32908    transactions transactions_pkey 
   CONSTRAINT     \   ALTER TABLE ONLY public.transactions
    ADD CONSTRAINT transactions_pkey PRIMARY KEY (id);
 H   ALTER TABLE ONLY public.transactions DROP CONSTRAINT transactions_pkey;
       public            postgres    false    207            ?
           2606    32875    workers workers_pkey 
   CONSTRAINT     R   ALTER TABLE ONLY public.workers
    ADD CONSTRAINT workers_pkey PRIMARY KEY (id);
 >   ALTER TABLE ONLY public.workers DROP CONSTRAINT workers_pkey;
       public            postgres    false    206            ?
           2620    32978 !   transactions transactions_handler    TRIGGER     ?   CREATE TRIGGER transactions_handler AFTER INSERT ON public.transactions FOR EACH ROW EXECUTE FUNCTION public.transaction_balance_adjustment();
 :   DROP TRIGGER transactions_handler ON public.transactions;
       public          postgres    false    220    207            ?
           2606    32923    clients client_worker 
   FK CONSTRAINT     x   ALTER TABLE ONLY public.clients
    ADD CONSTRAINT client_worker FOREIGN KEY (worker_id) REFERENCES public.workers(id);
 ?   ALTER TABLE ONLY public.clients DROP CONSTRAINT client_worker;
       public          postgres    false    209    206    2726            ?
           2606    32928    filiation filiation_worker 
   FK CONSTRAINT     {   ALTER TABLE ONLY public.filiation
    ADD CONSTRAINT filiation_worker FOREIGN KEY (boss_id) REFERENCES public.workers(id);
 D   ALTER TABLE ONLY public.filiation DROP CONSTRAINT filiation_worker;
       public          postgres    false    206    2726    204            ?
           2606    32938 "   transactions transaction_recipient 
   FK CONSTRAINT     ?   ALTER TABLE ONLY public.transactions
    ADD CONSTRAINT transaction_recipient FOREIGN KEY (recipient_id) REFERENCES public.clients(id);
 L   ALTER TABLE ONLY public.transactions DROP CONSTRAINT transaction_recipient;
       public          postgres    false    207    209    2730            ?
           2606    32933    transactions transaction_sender 
   FK CONSTRAINT     ?   ALTER TABLE ONLY public.transactions
    ADD CONSTRAINT transaction_sender FOREIGN KEY (sender_id) REFERENCES public.clients(id);
 I   ALTER TABLE ONLY public.transactions DROP CONSTRAINT transaction_sender;
       public          postgres    false    207    2730    209            ?
           2606    32943    workers worker_boss 
   FK CONSTRAINT     t   ALTER TABLE ONLY public.workers
    ADD CONSTRAINT worker_boss FOREIGN KEY (boss_id) REFERENCES public.workers(id);
 =   ALTER TABLE ONLY public.workers DROP CONSTRAINT worker_boss;
       public          postgres    false    206    206    2726            ?
           2606    32948    workers worker_filiation 
   FK CONSTRAINT     ?   ALTER TABLE ONLY public.workers
    ADD CONSTRAINT worker_filiation FOREIGN KEY (filiation_id) REFERENCES public.filiation(id);
 B   ALTER TABLE ONLY public.workers DROP CONSTRAINT worker_filiation;
       public          postgres    false    206    204    2724           