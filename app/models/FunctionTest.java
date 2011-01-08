package models;

import play.db.jpa.Model;

import javax.persistence.*;
import java.util.Date;

/**
 * Dominik Dorn
 * 0626165
 * dominik.dorn@tuwien.ac.at
 */
@Entity
@Table(uniqueConstraints = {
        @UniqueConstraint(columnNames = {"function_id", "testrun_id"})
})
public class FunctionTest extends Model {

    @ManyToOne(optional = false)
    public Function function;

    @ManyToOne(optional = false)
    public TestRun testRun;

    public boolean passed;

    @Temporal(value = TemporalType.TIMESTAMP)
    public Date creationDate;

    public String stdOut;

    public String stdErr;
}
