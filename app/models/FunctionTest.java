package models;

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
public class FunctionTest extends Model {

    @ManyToOne
    public Function function;

    @ManyToOne
    public TestRun testRun;

    public boolean passed;

    @Temporal(value = TemporalType.TIMESTAMP)
    public Date creationDate;

    public String result;

}
