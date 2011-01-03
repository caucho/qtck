package results;

import play.exceptions.UnexpectedException;
import play.mvc.Http;
import play.mvc.results.Result;

/**
 * Dominik Dorn
 * 0626165
 * dominik.dorn@tuwien.ac.at
 */
public class RenderPHPDownload extends Result {

    private String code;
    private String filename;

    public RenderPHPDownload(String filename, String code) {
        this.filename = filename;
        this.code = code;
    }

    @Override
    public void apply(Http.Request request, Http.Response response) {
        try {
            setContentTypeIfNotSet(response, "application/x-httpd-php5");
            response.setHeader("Content-Disposition","attachment; filename=\""+ filename +"\"");
            response.out.write(code.getBytes("utf-8"));
        } catch(Exception e) {
            throw new UnexpectedException(e);
        }

    }
}
