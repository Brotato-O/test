package hibernate_demo.entity;

import jakarta.persistence.Column;
import jakarta.persistence.Entity;
import jakarta.persistence.GeneratedValue;
import jakarta.persistence.GenerationType;
import jakarta.persistence.Id;
import jakarta.persistence.Table;

	//Annotation the class as an entity and map to DB table
@Entity
@Table(name="instructor_detail")
public class InstructorDetail {

	//Defile the fields
	//Annotation the fields
	@Id
	@GeneratedValue(strategy = GenerationType.IDENTITY)
	@Column(name="id")
	private int id;
	
	@Column(name="youtube_channel")
	private String youtube_channel;
	
	@Column(name="hobby")
	private String hobby;
	
	//Create Constructors
	public InstructorDetail() {
		
	}
	
	public InstructorDetail(String youtube_channel, String hobby) {
		this.youtube_channel = youtube_channel;
		this.hobby = hobby;
	}
	//Generate getter/setter methods
	public int getId() {
		return id;
	}

	public void setId(int id) {
		this.id = id;
	}

	public String getYoutube_channel() {
		return youtube_channel;
	}

	public void setYoutube_channel(String youtube_channel) {
		this.youtube_channel = youtube_channel;
	}

	public String getHobby() {
		return hobby;
	}

	public void setHobby(String hobby) {
		this.hobby = hobby;
	}

	//Generate toString() methods
	
	@Override
	public String toString() {
		return "InstructorDetail [id=" + id + ", youtube_channel=" + youtube_channel + ", hobby=" + hobby + "]";
	}
	
}
