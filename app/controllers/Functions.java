package controllers;

import models.Function;
import play.mvc.Controller;
import results.RenderPHPDownload;

/**
 * Dominik Dorn
 * 0626165
 * dominik.dorn@tuwien.ac.at
 */
public class Functions extends Controller {

    public static void testCode(long id)
    {
        Function f = Function.findById(id);

        String testCode = Function.createTestCode(f);

        throw new RenderPHPDownload(id +".php", testCode);
    }
}
