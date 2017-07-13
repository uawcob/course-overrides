CREATE VIEW dbo.vwRequests AS
SELECT r.id
	,u.first_name
	,u.last_name
	,u.student_id
	,u.email
	,(
		SELECT CONCAT(p.name, ', ') AS [text()]
		FROM dbo.plans p
		WHERE type = 'major'
		 AND p.user_id = u.id
		FOR XML PATH ('')
	) majors
	,(
		SELECT CONCAT(p.name, ', ') AS [text()]
		FROM dbo.plans p
		WHERE type = 'minor'
		 AND p.user_id = u.id
		FOR XML PATH ('')
	) minors
	,r.created_at
	,s.course
	,LEFT(s.sections,LEN(s.sections)-1) AS section_preference
	,CASE WHEN r.enrolled = 1 THEN 'enrolled' ELSE 'no' END AS 'enrolled'
	,CASE WHEN r.required = 1 THEN 'required' ELSE 'no' END AS 'required'
	,r.comment
	,r.inclass
FROM dbo.requests r
JOIN dbo.users u
  ON u.id = r.user_id
JOIN (
    SELECT DISTINCT crb.request_id, (
		SELECT TOP 1 c.code
		FROM dbo.courses c
		WHERE c.id = crb.course_id
	) course, (
        SELECT CONCAT(c.number, '(', c.section, '), ') AS [text()]
        FROM dbo.course_request cra
		JOIN dbo.courses c
		  ON c.id = cra.course_id
        WHERE cra.request_id = crb.request_id
        ORDER BY cra.priority
        FOR XML PATH ('')
    ) sections
    FROM dbo.course_request crb
) s
  ON r.id = s.request_id;
