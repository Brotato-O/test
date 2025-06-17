<%@ page language="java" contentType="text/html; charset=UTF-8"
    pageEncoding="UTF-8"%>
    
<%@ taglib uri="http://www.springframework.org/tags/form" prefix="form" %>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
	<title>Customer Registration Form</title>
	<style>
		.error {
			color: red;
		}
	</style>

</head>
<body>

	<i>Fill out the form. Asterisk (*) means required.</i>

	<form:form action="processForm" modelAttribute="customer">
		 First Name   : <form:input path="firstName"/> <br>
		 last Name(*) : <form:input path="lastName"/>
		 <form:errors path="lastName" cssClass="error"></form:errors> <br>
		<input type="submit" name="Submit">
	</form:form>

</body>
</html>