package hibernate_demo;

import org.hibernate.SessionFactory;
import org.hibernate.cfg.Configuration;

import hibernate_demo.entity.Student;

import org.hibernate.Session;

public class CreateStudentDemo {
	public static void main(String[] args) {
		
		//Create session factory
		SessionFactory factory = new Configuration().configure("hibernate.cfg.xml").
				addAnnotatedClass(Student.class).buildSessionFactory();
		
		//Create session
		Session session = factory.getCurrentSession();
		
		try {
			//create a student object 
			System.out.println("Create new student object ...");
			Student tempStudent = new Student("Kai","SKTT1","kai@gmail.com");
			
			//start a transaction
			session.beginTransaction();
			
			//save the student object
			System.out.println("Saving the student ...");
			session.persist(tempStudent);
			
			//commit transaction
			session.getTransaction().commit();
			System.out.println("Done!");
			
		} catch (Exception e) {
			
		} finally {
			factory.close();
		}
		
	}
}
