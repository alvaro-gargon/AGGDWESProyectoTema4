/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/SQLTemplate.sql to edit this template
 */
/**
 * Author:  alvaro.gargon.4
 * Created: 20 nov 2025
 */

create table if not exists T02_Departamento(
T02_CodDepartamento varchar(3),
T02_DescDepartamento varchar(255),
T02_VolumenDeNegocio float,
T02_FechaCreacionDepartamento datetime,
T02_FechaBajaDepartamento datetime,
primary key(T02_CodDepartamento)
)engine=innodb;

--creo el usuario con todos los privilegios sobre la base de datos

use DBAGGDWESProyectoTema4;

--relleno los campos
insert into T02_Departamento (T02_CodDepartamento,T02_DescDepartamento,T02_FechaCreacionDepartamento,T02_VolumenDeNegocio,T02_FechaBajaDepartamento) values
        ('INF','Departamento de informatica.',now(),1235.5,null),
        ('AUT','Departamento de automocion.',now(),5235.8,null),
        ('ELE','Departamento de electricidad.',now(),2275.1,null),
        ('MAT','Departamento de matematicas.',now(),735.2,null),
        ('ING','Departamento de ingles.',now(),235.9,'2026-02-17 23:45:37');