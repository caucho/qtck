package controllers;

import models.TestRun;
import play.data.validation.Valid;
import play.data.validation.Validation;
import play.libs.Codec;
import play.mvc.Controller;
import play.mvc.With;

import java.util.Date;

/**
 * Dominik Dorn
 * 0626165
 * dominik.dorn@tuwien.ac.at
 */
@With(Secure.class)
public class TestRunCreateController extends Controller {


    public static void createForm(TestRun testrun)
    {
        render(testrun);
    }

    public static void create(TestRun testrun)
    {
        testrun.member = Security.getLoggedInUser();
        testrun.creationDate = new Date();
        testrun.uuid = Codec.UUID();



        Validation.ValidationResult res = validation.valid(testrun);
        if(!res.ok)

//        if(validation.hasErrors())
        {
            params.flash();
            validation.keep();
            render("TestRunCreateController/createForm.html", testrun);
        }
        else
        {
            testrun.save();
            Testruns.show(testrun.id);
        }
    }
}
