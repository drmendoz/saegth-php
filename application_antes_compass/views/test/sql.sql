select p.id, p.nombre_p,u.user_name,u.password,u.token from users as u 
join personal as p
on p.id = u.id_personal
where nombre_p LIKE "%alexander%"

select * from multifuente_evaluado where cod_test="test209315-07-17"
