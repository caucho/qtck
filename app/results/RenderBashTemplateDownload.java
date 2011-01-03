package results;

import play.exceptions.UnexpectedException;
import play.mvc.Http;
import play.mvc.results.Result;
import play.templates.GroovyTemplate;
import play.templates.Template;

import java.util.Map;

/**
 * Dominik Dorn
 * 0626165
 * dominik.dorn@tuwien.ac.at
 */
public class RenderBashTemplateDownload extends Result {

    private String filename;
    private String content;

    public RenderBashTemplateDownload(String resultFilename, String templateFilename, Map<String, Object> args) {
        this.filename = resultFilename;
        Template t = new GroovyTemplate(templateFilename);
//        t.compile();
        content = t.render(args);
    }

    @Override
    public void apply(Http.Request request, Http.Response response) {
        try {
            setContentTypeIfNotSet(response, "application/x-sh");
            response.setHeader("Content-Disposition", "attachment; filename=\"" + filename + "\"");
            response.out.write(content.getBytes("utf-8"));
        } catch(Exception e) {
            throw new UnexpectedException(e);
        }
    }
}
