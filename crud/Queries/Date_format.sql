SELECT DATE_FORMAT(`created_datetime`,'%h:%i %p') as startTime from customers where id = 1;
SELECT concat(DATE_FORMAT(`created_datetime`,'%W'),", ", DATE_FORMAT(`created_datetime`,'%M %D'),", ", 
DATE_FORMAT(`created_datetime`,'%Y')) as StartDate from customers where id = 1;