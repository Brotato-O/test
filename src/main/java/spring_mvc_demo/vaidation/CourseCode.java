package spring_mvc_demo.vaidation;

import java.lang.annotation.ElementType;
import java.lang.annotation.Retention;
import java.lang.annotation.RetentionPolicy;
import java.lang.annotation.Target;

import jakarta.validation.Constraint;
import jakarta.validation.Payload;

@Constraint(validatedBy = CourseCodeConstraintValidator.class)
@Target({ 
	ElementType.METHOD,ElementType.FIELD
})
@Retention(RetentionPolicy.RUNTIME)
public @interface CourseCode {

	//define default course code
	public String value() default "SKTT1";
	
	//define default error message
	public String message() default "must start with SKTT1";
	
	//define default groups
	public Class<?>[] groups() default {
		
	};
	//define default payloads
	public Class<? extends Payload>[] payload() default {
		
	};
}

