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
public class Constant extends Model {

    @ManyToOne
    public Module module;

    public String name;
    public String shortname;
    public String description;
    public String type;
    public String defaultvalue;


    public static List<Constant> findByModule(Module module) {

//        echo "in findByModule of ConstantObject <br/>\n";
        return Constant.find("SELECT c FROM Constant c WHERE c.module.id = ? ORDER BY c.name",
                module.id
        ).fetch();
    }

    public static String createTestCode(Constant constant) {
        String name = constant.name;
        StringBuilder testCode = new StringBuilder(500);

        testCode.append("<?\n");
        testCode.append("if( defined(\"").append(name).append("\") ) { echo \"SUCCESS\"; } else { echo \"FAILED\"; }\n");
        testCode.append("?>");

        return testCode.toString();
    }
}
