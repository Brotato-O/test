package hibernate_demo;

import org.hibernate.SessionFactory;
import org.hibernate.cfg.Configuration;

import hibernate_demo.entity.Instructor;
import hibernate_demo.entity.InstructorDetail;
import hibernate_demo.entity.Student;

import org.hibernate.Session;

public class CreateInstructorDemo {
	public static void main(String[] args) {
		
		//Create session factory
		//Create session factory
		SessionFactory factory = new Configuration()
		        .configure("OneToOne.cfg.xml")
		        .addAnnotatedClass(Instructor.class)        
		        .addAnnotatedClass(InstructorDetail.class) 
		        .addAnnotatedClass(Student.class)
		        .buildSessionFactory();
		
		//Create session
		Session session = factory.getCurrentSession();
		
		try {
			
			Instructor tempInstructor = new Instructor("KaiST2","Hello2","Kai2@gmai.com");
			
			InstructorDetail tempInstructorDetail = new InstructorDetail(
					"http://www.KaiST2.com/youtube", "KaiST2!!!"
					);
			tempInstructor.setInstructor_detail_id(tempInstructorDetail);		
			
			session.beginTransaction();
			
			// save the instructor
			//
			// Note: this will ALSO save the details object
			// because of CascadeType.ALL
			//

			
			System.out.println("\n\t\tSaving instructor : " + tempInstructor);
			session.persist(tempInstructor);
			
			session.getTransaction().commit();
			
		} catch (Exception e) {
			
		} finally {
			factory.close();
		}
		
	}
}
