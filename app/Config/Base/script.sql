CREATE TABLE tb_movements (
	id SERIAL,
	type_mov char(1) NOT NULL,
	date_mov date,
	id_rubric int,
	value_mov DECIMAL,
    origem VARCHAR(20)
	status CHAR(1),
	CONSTRAINT id_mov_pk PRIMARY KEY(id)
);