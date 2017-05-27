SELECT tasks.id, em.name, em1.name as asname
FROM employees em
left join tasks on tasks.authorId = em.id 
left join employees em1 on tasks.assigneeId = em1.id 
order by id asc

show create table tasks;