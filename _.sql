-- Ne pas toucher la table utilisateur d'abord
CREATE TABLE Users(
   u_id SERIAL PRIMARY KEY,
   u_prenom VARCHAR(60),
   u_nom VARCHAR(30),
   u_type VARCHAR(6),
   u_tel VARCHAR(25),
   password VARCHAR(80),
   PRIMARY KEY(u_id)
);


-- Tables modeles
CREATE TABLE Modeles(
   m_id SERIAL PRIMARY KEY,
   m_nom VARCHAR(60) NOT NULL,
   m_couleur VARCHAR(100) NOT NULL,
   m_type VARCHAR(25) NOT NULL,
   m_memoire INT NOT NULL,
   m_qte DECIMAL(15,2),
   m_prix DECIMAL(15,2),
   m_date DATETIME,
   m_annee INT NOT NULL,
   m_numero VARCHAR(60) NOT NULL,
   PRIMARY KEY(m_id),
   UNIQUE(m_nom)
);


-- Tables iphones
CREATE TABLE Iphone(
   i_id SERIAL PRIMARY KEY,
   i_nom VARCHAR(100) NOT NULL,
   i_serie VARCHAR(200) NOT NULL,
   i_barcode VARCHAR(100) NOT NULL,
   i_poids DECIMAL(15,2) NOT NULL,
   i_hauteur DECIMAL(15,2) NOT NULL,
   i_largeur DECIMAL(15,2) NOT NULL,
   i_epaisseur DECIMAL(15,2) NOT NULL,
   i_ecran DECIMAL(15,2) NOT NULL,
   m_id INT NOT NULL,
   PRIMARY KEY(i_id),
   FOREIGN KEY(m_id) REFERENCES Modeles(m_id)
);

-- Table Fournisseurs
CREATE TABLE Fournisseurs(
   f_id SERIAL PRIMARY KEY,
   f_nom VARCHAR(100) NOT NULL,
   f_tel VARCHAR(25) NOT NULL,
   f_adr VARCHAR(200) NOT NULL,
   PRIMARY KEY(f_id),
   UNIQUE(f_nom),
   UNIQUE(f_tel)
);

-- Table Clients
CREATE TABLE Clients(
   c_id SERIAL PRIMARY KEY,
   c_nom VARCHAR(100) NOT NULL,
   c_tel VARCHAR(25) NOT NULL,
   c_adr VARCHAR(200) NOT NULL,
   c_type VARCHAR(50) NOT NULL,
   PRIMARY KEY(c_id),
   UNIQUE(c_nom),
   UNIQUE(c_tel)
);


-- Tables vendres
CREATE TABLE Vendres(
   v_id SERIAL PRIMARY KEY,
   v_date DATETIME,
   v_type CHAR(3),
   v_etat INT,
   c_id INT NOT NULL,
   PRIMARY KEY(v_id),
   FOREIGN KEY(c_id) REFERENCES Clients(c_id)
);

-- La date est par defaut
-- Type de vente sim ou rev
-- Etat de la vente : en cours, en revente, valider

-- Table Achats
CREATE TABLE Achats(
   a_id SERIAL PRIMARY KEY,
   a_date DATETIME,
   a_etat INT,
   f_id INT NOT NULL,
   PRIMARY KEY(a_id),
   FOREIGN KEY(f_id) REFERENCES Fournisseurs(f_id)
);

-- Table Reductions
CREATE TABLE Reductions(
   r_id INT,
   r_nom VARCHAR(50) NOT NULL,
   r_type CHAR(3),
   r_pourcentage DECIMAL(15,2) NOT NULL,
   PRIMARY KEY(r_id),
   UNIQUE(r_nom)
);

-- Table Vreductions
CREATE TABLE Vreductions(
   vr_id INT,
   vr_etat INT,
   r_id INT NOT NULL,
   PRIMARY KEY(vr_id),
   FOREIGN KEY(r_id) REFERENCES Reductions(r_id)
);

-- Table Vpaiements en cours
CREATE TABLE Vpaiements(
   vp_id SERIAL PRIMARY KEY,
   vp_motif VARCHAR(200) NOT NULL,
   vp_date DATETIME,
   vp_montant INT,
   v_id SERIAL PRIMARY KEY NOT NULL,
   PRIMARY KEY(vp_id),
   FOREIGN KEY(v_id) REFERENCES Vendres(v_id)
);


-- Table Acommandes
CREATE TABLE Acommandes(
   ac_id INT,
   i_id INT,
   a_id INT,
   ac_etat INT,
   ac_qte DECIMAL(15,2),
   ac_prix DECIMAL(15,2),
   PRIMARY KEY(i_id, a_id),
   FOREIGN KEY(i_id) REFERENCES Iphone(i_id),
   FOREIGN KEY(a_id) REFERENCES Achats(a_id)
);


-- Table Vcommandes
CREATE TABLE Vcommandes(
   vc_id INT,
   i_id INT,
   v_id INT,
   vc_id INT,
   vc_qte DECIMAL(15,2),
   vc_prix DECIMAL(15,2),
   vc_etat INT,
   vc_motif VARCHAR(200),
   PRIMARY KEY(i_id, v_id),
   FOREIGN KEY(i_id) REFERENCES Iphone(i_id),
   FOREIGN KEY(v_id) REFERENCES Vendres(v_id)
);

-- Table Appliquer
CREATE TABLE Appliquer(
   ap_id INT,
   v_id INT,
   vr_id INT,
   PRIMARY KEY(v_id, vr_id),
   FOREIGN KEY(v_id) REFERENCES Vendres(v_id),
   FOREIGN KEY(vr_id) REFERENCES Vreductions(vr_id)
);

