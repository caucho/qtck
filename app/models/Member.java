package models;

import play.db.jpa.Model;
import play.libs.Crypto;

import javax.persistence.Column;
import javax.persistence.Entity;

/**
 * Dominik Dorn
 * 0626165
 * dominik.dorn@tuwien.ac.at
 */
@Entity
public class Member extends Model {

    public String email;

    @Column(name = "password", length = 36)
    public String password;


    public Member() {
    }

    public Member(String email, String password) {
        this.email = email;
        this.password = Crypto.passwordHash(password);
    }

    public static Member connect(String email, String password)
    {
        String passwordHash = play.libs.Crypto.passwordHash(password);

        return Member.find("byEmailAndPassword", email, passwordHash).first();
    }
}
