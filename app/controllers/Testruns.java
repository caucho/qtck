package controllers;

import javassist.compiler.ast.Pair;
import models.*;
import play.data.validation.Required;
import play.data.validation.Valid;
import play.db.DB;
import play.db.jpa.JPA;
import play.libs.Codec;
import play.mvc.Controller;
import play.mvc.Scope;
import play.mvc.With;
import results.RenderBashTemplateDownload;

import java.io.File;
import java.io.FileNotFoundException;
import java.io.FileReader;
import java.sql.ResultSet;
import java.util.*;

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



    public static void detail(long id)
    {
        TestRun testRun = TestRun.findById(id);

        List<Module> modules = Module.findAll();

        List<Object[]> functionTestResults = JPA.em().createNativeQuery("SELECT a.name as \"Module Name\", a.id as \"Module ID\", b.id as \"Function ID\", b.name as \"Function Name\", c.passed, (c.stdout is not null) as \"hasStdoutData\", (c.stderr is not null) as \"hasStdErrData\", b.shortname FROM module a JOIN function b ON (b.module_id = a.id) LEFT JOIN functiontest c ON (c.function_id = b.id AND c.testrun_id = ?) order by a.id, b.name;")
                .setParameter(1, id).getResultList();

        SortedMap<Long, ArrayList<Object>> functionPerModule = new TreeMap<Long, ArrayList<Object>>();
        for(Object[] o : functionTestResults)
        {
            Long key = Long.valueOf((Integer) o[1]);
            if(!functionPerModule.containsKey(key))
            {
                functionPerModule.put(key, new ArrayList());
            }

            functionPerModule.get(key).add(o);
        }

        List<Object[]> constantTestResults = JPA.em().createNativeQuery("SELECT a.name as \"Module Name\", a.id as \"Module ID\", b.id as \"Constant ID\", b.name as \"Constant Name\", c.passed, (c.stdout is not null) as \"hasStdoutData\", (c.stderr is not null) as \"hasStdErrData\" FROM module a JOIN constant b ON (b.module_id = a.id) LEFT JOIN constanttest c ON (c.constant_id = b.id AND c.testrun_id = ?) order by a.id, b.name;")
                .setParameter(1, id).getResultList();

        SortedMap<Long, ArrayList<Object>> constantPerModule = new TreeMap<Long, ArrayList<Object>>();

        for(Object[] o : constantTestResults)
        {
            Long key = Long.valueOf((Integer) o[1]);
            if(!constantPerModule.containsKey(key))
            {
                constantPerModule.put(key, new ArrayList());
            }

            constantPerModule.get(key).add(o);
        }


        List<Object[]> functionSuccessPerModule = JPA.em().createNativeQuery("select a.id, count(b.id) as \"TOTAL\", count(c.id) as \"SUCCEEDED\", count(b.id) - count(c.id) as \"FAILED\"  FROM module a JOIN function b ON (b.module_id = a.id) LEFT JOIN functiontest c ON (c.function_id = b.id AND c.testrun_id = ? AND c.passed) group by a.id order by a.id;")
                .setParameter(1, id).getResultList();

        List<Object[]> constantSuccessPerModule = JPA.em().createNativeQuery("select a.id, count(b.id) as \"TOTAL\", count(c.id) as \"SUCCEEDED\", count(b.id) - count(c.id) as \"FAILED\"  FROM module a JOIN constant b ON (b.module_id = a.id) LEFT JOIN constanttest c ON (c.constant_id = b.id AND c.testrun_id = ? AND c.passed) group by a.id order by a.id;")
                .setParameter(1, id).getResultList();

        Map<Long, Object[]> functionSuccess = new HashMap<Long, Object[]>();
        for(Object[] o : functionSuccessPerModule)
        {
            functionSuccess.put(Long.valueOf((Integer) o[0]), o);
        }

        Map<Long, Object[]> constantSuccess = new HashMap<Long, Object[]>();
        for(Object[] o : constantSuccessPerModule)
        {
            constantSuccess.put(Long.valueOf((Integer) o[0]), o);
        }
        render(testRun, functionPerModule, constantPerModule, modules, functionSuccess, constantSuccess);
    }


    public static void testscript(String uuid){

        TestRun testRun = TestRun.find("byUuid", uuid).first();

        Map data = new HashMap();
        data.put("testRun", testRun);
        renderTemplate("Testruns/testscript.sh", data);

//        throw new RenderBashTemplateDownload("testrun_" + id + ".sh", "Testruns/testscript.sh", data);
    }


    public static void submitOtherTestResult(String uuid, String testType, long id, File stdout, File stderr) throws FileNotFoundException {
        TestRun testRun = TestRun.find("byUuid", uuid).first();
        Date now = new Date();

        Map<String,String> result = new HashMap<String,String>();
        result.put("uuid", uuid);
        result.put("testType", testType);
        result.put("id", String.valueOf(id));

        if("FUNCTION".equals(testType))
        {
            FunctionTest ft = new FunctionTest();

            Function f = Function.findById(id);

            ft.creationDate = now;
            ft.passed = false;
            ft.testRun = testRun;
            ft.function = f;

            if(stdout != null)
            {
                StringBuffer buf = new StringBuffer(2000);
                Scanner scanner = new Scanner(stdout);
                while(scanner.hasNextLine())
                {
                    buf.append(scanner.nextLine()).append("\n");
                }
                ft.stdOut = buf.toString();
            }
            if(stderr != null)
            {
                StringBuffer buf = new StringBuffer(2000);
                Scanner scanner = new Scanner(stderr);
                while(scanner.hasNextLine())
                {
                    buf.append(scanner.nextLine()).append("\n");
                }
                ft.stdErr = buf.toString();
            }
            ft.save();
        }
        else if ("CONSTANT".equals(testType))
        {
            ConstantTest ct = new ConstantTest();

            Constant c = Constant.findById(id);

            ct.creationDate = now;
            ct.passed = false;
            ct.testRun = testRun;
            ct.constant = c;

            if(stdout != null)
            {
                StringBuffer buf = new StringBuffer(2000);
                Scanner scanner = new Scanner(stdout);
                while(scanner.hasNextLine())
                {
                    buf.append(scanner.nextLine()).append("\n");
                }
                ct.stdOut = buf.toString();
            }
            if(stderr != null)
            {
                StringBuffer buf = new StringBuffer(2000);
                Scanner scanner = new Scanner(stderr);
                while(scanner.hasNextLine())
                {
                    buf.append(scanner.nextLine()).append("\n");
                }
                ct.stdErr = buf.toString();
            }
            ct.save();
        }
        renderJSON(result);
    }

    public static void submitTestResult(String uuid,
                                        String testType,
                                        String resultType,
                                        File data) throws FileNotFoundException {
        Map<String,String> responseData = new HashMap<String,String>();
        responseData.put("uuid", uuid);
        responseData.put("type", testType);
        responseData.put("result", resultType);

        if(data != null)
        {
            Scanner scanner = new Scanner(data);

            TestRun testRun = TestRun.find("byUuid", uuid).first();
            Date now = new Date();
            Long testCount = 0l;
            while(scanner.hasNextLong())
            {
                long id = scanner.nextLong();
                if("CONSTANTS".equals(testType))
                {
                    Constant c = Constant.findById(id);
                    ConstantTest test = new ConstantTest();
                    test.constant = c;
                    test.testRun = testRun;
                    test.creationDate = now;
                    test.passed = "SUCCESS".equals(resultType);

                    test.save();
                    System.out.println("saved constantTest");
                }

                if("FUNCTIONS".equals(testType)){
                    Function f = Function.findById(id);

                    FunctionTest test = new FunctionTest();
                    test.function = f;
                    test.testRun = testRun;
                    test.creationDate = now;
                    test.passed = "SUCCESS".equals(resultType);

                    test.save();
//                    System.out.println("saved functionTest");
                }
                testCount++;
//                System.out.println(resultType + ": id = " + id);
            }

            responseData.put("persistedTests", String.valueOf(testCount));
        }
        renderJSON(responseData);
//        else
//        {
//            System.out.println("data is null");
//            System.out.println("no testresults");
//        }

    }



    public static void markFinished(@Required String uuid)
    {
        TestRun run = TestRun.find("byUuid", uuid).first();
        run.completed = true;
        run.save();
    }
}
