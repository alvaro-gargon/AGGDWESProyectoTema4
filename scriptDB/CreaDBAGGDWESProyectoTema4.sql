
/**
 * Author:  alvaro.gargon.4
 * Created: 28 oct 2025
 * Creacion de base de datos y usuario
 */
-- Creacion de la base de datos
create database if not exists DBAGGDWESProyectoTema4;
-- me situo en ella
use DBAGGDWESProyectoTema4;


--creamos la tabla sino existe, y nunca deberia existir
create table if not exists T02_Departamento(
T02_CodDepartamento varchar(3),
T02_DescDepartamento varchar(255),
T02_VolumenDeNegocio float,
T02_FechaCreacionDepartamento datetime,
T02_FechaBajaDepartamento datetime,
primary key(T02_CodDepartamento)
)engine=innodb;

--creo el usuario con todos los privilegios sobre la base de datos
create user if not exists'userAGGDWESProyectoTema4'@'%' identified by 'paso';
grant all on DBAGGDWESProyectoTema4.* to 'userAGGDWESProyectoTema4'@'%' with grant option;
--refrescamos los privilegios para asegurarnos que se ha actualizado
flush privileges;