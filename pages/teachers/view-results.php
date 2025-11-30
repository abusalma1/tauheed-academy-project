SELECT
t.id AS term_id,
t.name AS term_name,
t.session_id,

s.id AS student_id,
s.name AS student_name,
s.admission_number,
s.class_id,
s.arm_id,

scr.id AS student_class_record_id,

str.id AS student_term_record_id,
str.total_marks,
str.average_marks,
str.position_in_class,
str.class_size,
str.overall_grade

FROM terms t

-- Get all students in the class (and arm if needed)
CROSS JOIN students s

LEFT JOIN student_class_records scr
ON scr.student_id = s.id
AND scr.session_id = t.session_id
AND scr.class_id = s.class_id
AND scr.arm_id = s.arm_id

LEFT JOIN student_term_records str
ON str.student_class_record_id = scr.id
AND str.term_id = t.id

WHERE t.session_id = :session_id
AND s.class_id = :class_id
/* uncomment if selecting by arm also */
-- AND s.arm_id = :arm_id

ORDER BY
t.id,
s.name;