package hibernate_demo;

import org.hibernate.SessionFactory;
import org.hibernate.cfg.Configuration;

import hibernate_demo.entity.Student;

import org.hibernate.Session;

public class PrimaryKeyDemo {
	public static void main(String[] args) {
		
		//Create session factory
		SessionFactory factory = new Configuration().configure("hibernate.cfg.xml").
				addAnnotatedClass(Student.class).buildSessionFactory();
		
		//Create session
		Session session = factory.getCurrentSession();
		
		try {
			//create a student object 
			System.out.println("Create new student object ...");
			Student tempStudent1 = new Student("Kai1","SKTT1","kai1@gmail.com");
			Student tempStudent2 = new Student("Kai2","SKTT1","kai2@gmail.com");
			Student tempStudent3 = new Student("Kai3","SKTT1","kai3@gmail.com");
			
			//start a transaction
			session.beginTransaction();
			
			//save the student object
			System.out.println("Saving the student ...");
			session.persist(tempStudent1);
			session.persist(tempStudent2);
			session.persist(tempStudent3);
			
			//commit transaction
			session.getTransaction().commit();
			System.out.println("Done!");
			
		} catch (Exception e) {
			
		} finally {
			factory.close();
		}
		
	}
}
