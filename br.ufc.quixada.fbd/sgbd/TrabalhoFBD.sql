
CREATE TABLE Turista (
  email VARCHAR(255) NOT NULL,
  nome VARCHAR(255) NOT NULL,
  dataDeNascimento VARCHAR(15) NULL,
  senha VARCHAR(255) NOT NULL,
  CONSTRAINT Turista_pkey PRIMARY KEY(email)
);

CREATE TABLE PontoTuristico (
  idPontoTuristico SERIAL NOT NULL,
  nome VARCHAR(255) NOT NULL,
  latitude VARCHAR(255) NOT NULL,
  longitude VARCHAR(255) NOT NULL,
  precoDaEntrada DECIMAL NULL,
  horarioAbertura VARCHAR(25) NULL,
  horarioFechamento VARCHAR(25) NULL,
  CONSTRAINT PontoTuristico_pkey PRIMARY KEY(idPontoTuristico)
);


CREATE TABLE EnderecoPontoTuristico (
  idPontoTuristico INTEGER NOT NULL,
  rua VARCHAR(255) NOT NULL,
  cidade VARCHAR(255) NOT NULL,
  estado VARCHAR(255) NOT NULL,
  pais VARCHAR(255) NOT NULL,
  numero INTEGER NULL,
  bairro VARCHAR(255) NOT NULL,
  CONSTRAINT EnderecoPontoTuristico_FKey FOREIGN KEY(idPontoTuristico) REFERENCES PontoTuristico(idPontoTuristico) ON DELETE cascade
);


CREATE TABLE PreferenciaDeTurista (
  emailTurista VARCHAR(255) NOT NULL,
  nome VARCHAR(255) NOT NULL,
  CONSTRAINT PreferenciaDeTurista_FKey FOREIGN KEY(emailTurista) REFERENCES Turista(email) ON DELETE cascade
);

CREATE TABLE TagDePontoTuristico (
  idPontoTuristico INTEGER NOT NULL,
  nome VARCHAR(255) NOT NULL,
  CONSTRAINT TagDePontoTuristico_FKey FOREIGN KEY(idPontoTuristico) REFERENCES PontoTuristico(idPontoTuristico) ON DELETE cascade
);



CREATE TABLE Visitas (
  idPontoTuristico INTEGER NOT NULL,
  emailTurista VARCHAR(255) NOT NULL,
  dataDaVisita INTEGER NULL,
  CONSTRAINT Visitas_PKey PRIMARY KEY (emailTurista, idPontoTuristico),
  CONSTRAINT Visitas_FKey_idPontoTuristico FOREIGN KEY(idPontoTuristico) REFERENCES PontoTuristico(idPontoTuristico) ON DELETE cascade,
  CONSTRAINT Visitas_FKey_emailTurista FOREIGN KEY(emailTurista) REFERENCES Turista(email) ON DELETE cascade
);


CREATE TABLE Cadastrou (
  idPontoTuristico INTEGER NOT NULL UNIQUE,
  emailTurista VARCHAR(255) NOT NULL,
  CONSTRAINT Cadastrou_PKey PRIMARY KEY (emailTurista, idPontoTuristico),
  CONSTRAINT Cadastrou_FKey_idPontoTuristico FOREIGN KEY(idPontoTuristico) REFERENCES PontoTuristico(idPontoTuristico) ON DELETE cascade,
  CONSTRAINT Cadastrou_FKey_emailTurista FOREIGN KEY(emailTurista) REFERENCES Turista(email) ON DELETE cascade
);

CREATE TABLE PontoTuristicoFavoritoTurista (
	emailTurista VARCHAR(255) NOT NULL,
	idPontoTuristico int NOT NULL,
	CONSTRAINT PontoTuristicoFavoritoTurista_PKey PRIMARY KEY (emailTurista, idPontoTuristico),
	CONSTRAINT PontoTuristicoFavoritoTurista_FKey_emailTurista FOREIGN KEY(emailTurista) REFERENCES Turista(email) ON DELETE cascade,
	CONSTRAINT PontoTuristicoFavoritoTurista_FKey_idPontoTuristico FOREIGN KEY(idPontoTuristico) REFERENCES PontoTuristico(idPontoTuristico) ON DELETE cascade
);

CREATE TABLE AvaliacaoPontoTuristico (
	valorAvaliado int NOT NULL,
	emailTurista VARCHAR(255) NOT NULL,
	idPontoTuristico int NOT NULL,
	CONSTRAINT AvaliacaoPontoTuristico_PKey PRIMARY KEY (emailTurista, idPontoTuristico),
	CONSTRAINT AvaliacaoPontoTuristico_FKey_emailTurista FOREIGN KEY(emailTurista) REFERENCES Turista(email) ON DELETE cascade,
	CONSTRAINT AvaliacaoPontoTuristico_FKey_idPontoTuristico FOREIGN KEY(idPontoTuristico) REFERENCES PontoTuristico(idPontoTuristico) ON DELETE cascade
);
	
