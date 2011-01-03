package controllers;

import models.Constant;
import models.Function;
import models.Module;
import play.mvc.Controller;
import play.mvc.Router;
import results.RenderBashDownload;

import javax.persistence.NoResultException;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

/**
 * Dominik Dorn
 * 0626165
 * dominik.dorn@tuwien.ac.at
 */
public class Modules extends Controller {


    public static void show(long id)
    {
        Module module = Module.findById(id);

        List<Constant> constants = Constant.findByModule(module);
        List<Function> functions = Function.findByModule(module);

        Map<String, Boolean> constantStatus = new HashMap<String,Boolean>();
        Map<String, String> constantValues = new HashMap<String,String>();
        Map<String, Boolean> functionStatus = new HashMap<String,Boolean>();

        int constantsSuccessCount = 0;
        int constantsFailureCount = 0;

        for(Constant constant : constants)
        {
            constantStatus.put(constant.name, defined(constant));
            if (constantStatus.get(constant.name)) {
                constantsSuccessCount++;
                constantValues.put(constant.name, get_defined_value(constant));
            }
            else
            {
                constantsFailureCount++;
            }
        }

        double constantsSuccessRate = (constantsSuccessCount + constantsFailureCount > 0) ? (Math.round(constantsSuccessCount * 10000 / (constantsSuccessCount + constantsFailureCount)) / 100) : 100;

        int functionsSuccessCount = 0;
        int functionsFailureCount = 0;

        for(Function function : functions)
        {
            functionStatus.put(function.name, defined(function));
            if (functionStatus.get(function.name)) {
                functionsSuccessCount ++;
            }
            else
            {
                functionsFailureCount++;
            }
        }

        double functionsSuccessRate = (functionsSuccessCount  + functionsFailureCount > 0) ? (Math.round(functionsSuccessCount  * 10000 / (functionsSuccessCount  + functionsFailureCount)) / 100) : 100;

        render(
                id,
                module,
                constants,
                constantStatus,
                constantsSuccessCount,
                constantsFailureCount,
                constantsSuccessRate,
                constantValues,

                functions,
                functionStatus,
                functionsSuccessCount ,
                functionsFailureCount,
                functionsSuccessRate
                );

    }

    private static String get_defined_value(Constant constant) {
        return "";
    }

    private static Boolean defined(Function function) {
        // delegate to quercus "function_exists"

        return false;
    }

    private static Boolean defined(Constant constant) {
        // delegate to quercus "defined"
        return false;
    }

    public static void downloadTestScript(long id)
    {
        if(id < 1)
                throw new NoResultException();

        Module module = Module.findById(id);

        List<Constant> constants = Constant.findByModule(module);
        List<Function> functions = Function.findByModule(module);

        render("/Modules/downloadTestScript.sh", module, constants, functions);
    }


    public static void runTestScript(long id)
    {
        if(id < 1)
                throw new NoResultException();

        Module module = Module.findById(id);

        List<Constant> constants = Constant.findByModule(module);
        List<Function> functions = Function.findByModule(module);

        render("/Modules/runTestScript.sh", module, constants, functions);
    }
}
