package models;

import play.data.validation.Required;
import play.db.jpa.Model;

import javax.persistence.Entity;
import javax.persistence.ManyToOne;
import javax.persistence.Temporal;
import javax.persistence.TemporalType;
import java.util.Date;

/**
 * Dominik Dorn
 * 0626165
 * dominik.dorn@tuwien.ac.at
 */
@Entity
public class TestRun extends Model {
    
    @Required
    public String vendor;
    @Required
    public String product;
    @Required
    public String version;
    
    @Temporal(value = TemporalType.TIMESTAMP)
    public Date creationDate;

    public String uuid;

    @ManyToOne
    @Required
    public Member member;

    public boolean completed;


}
