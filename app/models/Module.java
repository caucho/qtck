package models;

import play.db.jpa.Model;

import javax.persistence.Entity;

/**
 * Dominik Dorn
 * 0626165
 * dominik.dorn@tuwien.ac.at
 */
@Entity
public class Module extends Model {
    public String name;
    public String shortname;

    public boolean deprecated;
}
