
/**
 * Author:  alvaro.gargon.4
 * Created: 28 oct 2025
 */

create database if not exists 'DBAGGDWESProyectoTema4';
use 'DBAGGDWESProyectoTema4';

drop table if exists 'T02_Departamento';
create table 'T02_Departamento'(
'T02_CodDepartamento' varchar(3),
'T02_DescDepartamento' varchar(255),
'T02_VolumenDeNegocio' float,
'T02_FechaCreacionDepartamento' date,
'T02_FechaBajaDepartamento' date,
primary key('T02_CodDepartamento')
)engine=innodb;
