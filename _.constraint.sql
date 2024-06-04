-- DB IPHONES CONTRAINTES

-- entreprises
alter table entreprises add constraint entreprises_unique1 unique(en_nom);
alter table entreprises add constraint entreprises_unique2 unique(en_tel);

-- utilisateurs
alter table users add constraint users_unique1 unique(u_username);
alter table users add constraint users_unique2 unique(u_prenom,u_nom,en_id);
alter table users add constraint users_check1 check(u_type in ('user','admin','root'));


-- modeles
alter table modeles add constraint modeles_unique1 unique(m_nom,m_type,m_memoire,en_id);

-- iphones
alter table iphones add constraint iphones_unique2 unique(i_barcode);

-- fournisseurs
alter table fournisseurs add constraint fournisseurs_unique1 unique(f_nom,en_id);
alter table fournisseurs add constraint fournisseurs_unique2 unique(f_tel);

-- clients
alter table clients add constraint clients_unique1 unique(c_nom,en_id);
alter table clients add constraint clients_unique2 unique(c_tel);
alter table clients add constraint clients_check1 check(c_type in ('SIMPLE','REVENDEUR'));


-- vendres
alter table vendres alter column v_date set default now()::date;
alter table vendres add constraint vendres_check1 check(v_type in ('SIM','REV'));
alter table vendres add constraint vendres_check2 check(v_etat > -1);

-- achats
alter table achats alter column a_date set default now()::date;
alter table achats add constraint achats_check2 check(a_etat > -1);

-- vpaiements
alter table vpaiements alter column vp_date set default now()::date;
alter table vpaiements add constraint vpaiements_check1 check(vp_montant > -1);

-- acommandes
-- alter table acommandes add constraint acommandes_unique1 unique(i_id);
alter table acommandes add constraint acommandes_check1 check(ac_qte > 0);
alter table acommandes add constraint acommandes_check2 check(ac_prix > -1);

-- vcommandes : oui l'iphone est unique dans la commande

-- alter table vcommandes add constraint vcommandes_unique1 unique(i_id);
alter table vcommandes add constraint vcommandes_check1 check(vc_qte > 0);
alter table vcommandes add constraint vcommandes_check2 check(vc_prix > -1);

-- retours
alter table retours add constraint retours_unique1 unique(i_id,en_id);
alter table retours add constraint retours_unique2 unique(i_ech_id,en_id);
