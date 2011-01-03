package controllers;

import models.Constant;
import play.mvc.Controller;
import results.RenderPHPDownload;

/**
 * Dominik Dorn
 * 0626165
 * dominik.dorn@tuwien.ac.at
 */
public class Constants extends Controller {

    public static void testCode(long id)
    {
        Constant c = Constant.findById(id);

        throw new RenderPHPDownload("constant_" + id + ".php", Constant.createTestCode(c));
    }
}
