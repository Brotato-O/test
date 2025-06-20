package hibernate_demo;


import org.hibernate.Session;
import org.hibernate.SessionFactory;
import org.hibernate.cfg.Configuration;

import hibernate_demo.entity.Student;

public class DeleteStudentDemo {
	public static void main(String[] args) {
		SessionFactory factory = new Configuration().configure("hibernate.cfg.xml")
				.addAnnotatedClass(Student.class).buildSessionFactory();
		
		Session session = factory.getCurrentSession();
		
		try {
			//C1
			int id1 = 1;
			int id =3;
			session.beginTransaction();
			
			Student myStudent = session.get(Student.class, id1);
			session.remove(myStudent);
			session.getTransaction().commit(); //Session bị đóng khi gọi lệnh
			
			//C2: Hay dùng để Delete All
			session = factory.getCurrentSession(); // Gọi mới Session 
			session.beginTransaction();
			session.createMutationQuery("DELETE Student WHERE id = :studentId").
				setParameter("studentId", id).executeUpdate();
			session.getTransaction().commit();
		} finally {
			factory.close();
		}
	}
}
