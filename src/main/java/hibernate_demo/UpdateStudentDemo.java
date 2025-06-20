package hibernate_demo;


import org.hibernate.Session;
import org.hibernate.SessionFactory;
import org.hibernate.cfg.Configuration;

import hibernate_demo.entity.Student;

public class UpdateStudentDemo {
	public static void main(String[] args) {
		SessionFactory factory = new Configuration().configure("hibernate.cfg.xml")
				.addAnnotatedClass(Student.class).buildSessionFactory();
		
		Session session = factory.getCurrentSession();
		
		try {
			//UPDATES OBJECTS PK
			int id = 4;
			session.beginTransaction();
			
			Student myStudent = session.get(Student.class, id);
			myStudent.setFirstName("Scooby");
			session.getTransaction().commit(); //Session bị đóng khi gọi lệnh
			
			//UPDATE ALL OBJECTS
			session = factory.getCurrentSession(); // Gọi mới Session 
			session.beginTransaction();
			session.createMutationQuery("UPDATE Student SET email = 'HelloWord@gmail.com'")
				.executeUpdate();
			session.getTransaction().commit();
		} finally {
			factory.close();
		}
	}
}
