
CREATE TABLE Turista (
  email VARCHAR(255) NOT NULL,
  nome VARCHAR(255) NULL,
  dataDeNascimento INTEGER NULL,
  senha VARCHAR(255) NULL,
  CONSTRAINT Turista_pkey PRIMARY KEY(email)
);

CREATE TABLE PontoTuristico (
  idPontoTuristico SERIAL NOT NULL,
  nome VARCHAR(255) NULL,
  latitude VARCHAR(255) NULL,
  longitude VARCHAR(255) NULL,
  precoDaEntrada DECIMAL NULL,
  horarioAbertura INTEGER NULL,
  horarioFechamento INTEGER NULL,
  CONSTRAINT PontoTuristico_pkey PRIMARY KEY(idPontoTuristico)
);


CREATE TABLE EnderecoPontoTuristico (
  idPontoTuristico INTEGER NOT NULL,
  rua VARCHAR(255) NULL,
  cidade VARCHAR(255) NULL,
  estado VARCHAR(255) NULL,
  pais VARCHAR(255) NULL,
  numero INTEGER NULL,
  bairro VARCHAR(255) NULL,
  CONSTRAINT EnderecoPontoTuristico_FKey FOREIGN KEY(idPontoTuristico) REFERENCES PontoTuristico(idPontoTuristico) ON DELETE cascade
);


CREATE TABLE PreferenciaDeTurista (
  emailTurista VARCHAR(255) NOT NULL,
  nome VARCHAR(255) NULL,
  CONSTRAINT PreferenciaDeTurista_FKey FOREIGN KEY(emailTurista) REFERENCES Turista(email) ON DELETE cascade
);

CREATE TABLE TagDePontoTuristico (
  idPontoTuristico INTEGER NOT NULL,
  nome VARCHAR(255) NULL,
  CONSTRAINT TagDePontoTuristico_FKey FOREIGN KEY(idPontoTuristico) REFERENCES PontoTuristico(idPontoTuristico) ON DELETE cascade
);



CREATE TABLE Visitas (
  idPontoTuristico INTEGER NOT NULL,
  emailTurista VARCHAR(255) NOT NULL,
  dataDaVisita INTEGER NULL,
  CONSTRAINT Visitas_FKey_idPontoTuristico FOREIGN KEY(idPontoTuristico) REFERENCES PontoTuristico(idPontoTuristico),
  CONSTRAINT Visitas_FKey_emailTurista FOREIGN KEY(emailTurista) REFERENCES Turista(email)
);


CREATE TABLE Cadastrou (
  idPontoTuristico INTEGER NOT NULL UNIQUE,
  emailTurista VARCHAR(255) NOT NULL,
  CONSTRAINT Cadastrou_FKey_idPontoTuristico FOREIGN KEY(idPontoTuristico) REFERENCES PontoTuristico(idPontoTuristico),
  CONSTRAINT Cadastrou_FKey_emailTurista FOREIGN KEY(emailTurista) REFERENCES Turista(email)
);

CREATE TABLE PontoTuristicoFavoritoTurista (
	emailTurista VARCHAR(255) NOT NULL,
	idPontoTuristico int NOT NULL,
	CONSTRAINT PontoTuristicoFavoritoTurista_FKey_emailTurista FOREIGN KEY(emailTurista) REFERENCES Turista(email) ON DELETE cascade,
	CONSTRAINT PontoTuristicoFavoritoTurista_FKey_idPontoTuristico FOREIGN KEY(idPontoTuristico) REFERENCES PontoTuristico(idPontoTuristico) ON DELETE cascade
);
