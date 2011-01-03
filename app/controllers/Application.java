package controllers;

import play.*;
import play.mvc.*;

import java.util.*;

import models.*;

public class Application extends Controller {

    public static void index() {

        List<Module> modules = Module.findAll();

        render(modules);
    }


    @Before
    public static void beforeEverything()
    {

    }


    public static void modulesTestScript(String uuid)
    {
        renderArgs.put("format", "sh");
        List<Module> modules = Module.findAll();

        render("Application/modulesTestScript.sh", modules);
    }
}