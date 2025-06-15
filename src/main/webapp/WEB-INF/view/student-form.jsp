<%@ page language="java" contentType="text/html; charset=UTF-8"
    pageEncoding="UTF-8"%>
<%@ taglib prefix="form" uri="http://www.springframework.org/tags/form" %>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Insert title here</title>
</head>
<body>
	
	<form:form action="processForm" modelAttribute="student">
	
		First name: <form:input path="firstName"/> <br>
		Last name: <form:input path="lastName"/> <br>
		
		<form:select path="country">
			<form:options items="${student.countryOptions}"></form:options>
		</form:select> <br>
		
		Favorite Language:
		Java <form:radiobutton path="favoriteLanguage" value="Java"/> 
		C# <form:radiobutton path="favoriteLanguage" value="C#"/> 
		PHP <form:radiobutton path="favoriteLanguage" value="PHP"/> 
		Ruby <form:radiobutton path="favoriteLanguage" value="Ruby"/> <br>
		
		Operating Systems:
		Linux <form:checkbox path="operatingSystems" value="Linux"/>
		Mac OS <form:checkbox path="operatingSystems" value="Mac OS"/>
		MS Windows <form:checkbox path="operatingSystems" value="MS Windows"/>
		
		<input type="submit" value="Submit">
		
	</form:form>

</body>
</html>