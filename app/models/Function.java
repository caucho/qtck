package models;

import play.db.jpa.Model;

import javax.persistence.Entity;
import javax.persistence.ManyToOne;
import javax.persistence.OneToMany;
import java.util.List;

/**
 * Dominik Dorn
 * 0626165
 * dominik.dorn@tuwien.ac.at
 */
@Entity
public class Function extends Model {
    @ManyToOne
    public Module module;

    public String name;
    public String shortname;
    public String description;

    public boolean isAlias;
    public boolean isLanguageConstruct;

    public static List<Function> findByModule(Module m)
    {
        return Function.find("SELECT f FROM Function f WHERE f.module.id = ? ORDER BY f.name",m.id).fetch();
    }


    public static String createTestCode(Function $function)
    {
        String $functionName = $function.name;

        StringBuilder testCode = new StringBuilder(500);

        testCode.append("<?\n");
        testCode.append("if( function_exists(\"").append($functionName).append("\") ) { echo \"SUCCESS\"; } else { echo \"FAILED\"; }\n");
        testCode.append("?>");

        return testCode.toString();
    }



}
