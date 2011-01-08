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
        @UniqueConstraint(columnNames = {"constant_id", "testrun_id"})
})
public class ConstantTest extends Model {

    @ManyToOne(optional = false)
    public Constant constant;

    @ManyToOne(optional = false)
    public TestRun testRun;

    public boolean passed;

    @Temporal(value = TemporalType.TIMESTAMP)
    @Column(nullable = false)
    public Date creationDate;

    @Column(nullable = true)
    public String stdOut;

    @Column(nullable = true)
    public String stdErr;

}
