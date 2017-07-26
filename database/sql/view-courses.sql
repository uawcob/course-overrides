CREATE VIEW dbo.vwCourses AS
SELECT [semester]
      ,[number]
      ,[code]
      ,[section]
      ,[title]
      ,[time]
      ,[enabled]
FROM [dbo].[courses]
