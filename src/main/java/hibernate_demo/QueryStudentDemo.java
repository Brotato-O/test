package hibernate_demo;


import org.hibernate.Session;
import org.hibernate.SessionFactory;
import org.hibernate.cfg.Configuration;

import hibernate_demo.entity.Student;

public class QueryStudentDemo {
	public static void main(String[] args) {
		SessionFactory factory = new Configuration().configure("hibernate.cfg.xml")
				.addAnnotatedClass(Student.class).buildSessionFactory();
		
		Session session = factory.getCurrentSession();
		
		try {
			session.beginTransaction();
			
			//query students
			java.util.List<Student> theStudents = session.createQuery(
					"FROM Student s WHERE s.firstName ='Kai1'", 
					Student.class).getResultList();
			
			//display students
			for (Student student : theStudents) {
				System.out.println("\n\t\t" + student);
			}
			
			session.getTransaction().commit();
			
		} finally {
			factory.close();
		}
	}
}
