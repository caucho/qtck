package controllers;

import models.Member;
import models.TestRun;
import play.data.validation.Valid;
import play.libs.Codec;
import play.mvc.Controller;
import play.mvc.Scope;
import play.mvc.With;
import results.RenderBashTemplateDownload;

import java.io.File;
import java.util.Date;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

/**
 * Dominik Dorn
 * 0626165
 * dominik.dorn@tuwien.ac.at
 */
public class Testruns extends Controller {



    public static void index()
    {
        List<TestRun> testRuns = TestRun.findAll();

        render(testRuns);
    }


    public static void show(long id)
    {
        TestRun testrun = TestRun.findById(id);

        render(testrun);
    }




    public static void testscript(String uuid){

        TestRun testRun = TestRun.find("byUuid", uuid).first();

        Map data = new HashMap();
        data.put("testRun", testRun);
        renderTemplate("Testruns/testscript.sh", data);

//        throw new RenderBashTemplateDownload("testrun_" + id + ".sh", "Testruns/testscript.sh", data);
    }


    public static void submitTestResult(String uuid,

                                        String testType,
                                        String resultType,
                                        File data)
    {
        System.out.println("parsing a testResult");
        System.out.println("uuid = " + uuid);
        System.out.println("testType = " + testType);
        System.out.println("resultType = " + resultType);
        System.out.println("data = " + data);
    }
}
