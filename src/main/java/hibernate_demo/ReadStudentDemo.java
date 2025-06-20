package hibernate_demo;

import org.hibernate.Session;
import org.hibernate.SessionFactory;
import org.hibernate.cfg.Configuration;

import hibernate_demo.entity.Student;

public class ReadStudentDemo {
	public static void main(String[] args) {
		SessionFactory factory = new Configuration().configure("hibernate.cfg.xml")
				.addAnnotatedClass(Student.class).buildSessionFactory();
		
		Session session = factory.getCurrentSession();
		
		try {
			String id = "2";
			session.beginTransaction();
			
			Student student = session.get(Student.class, id);
			if (student != null) {
                System.out.println("\n\t\tĐã tìm thấy student: " + student);
            } else {
                System.out.println("\n\t\tKhông tìm thấy student với ID: " + id);
            }
			session.getTransaction().commit();
			
		} finally {
			factory.close();
		}
	}
}
