import com.orientechnologies.orient.client.remote.OServerAdmin;
import org.apache.log4j.Logger;

import java.io.IOException;
import java.util.List;

import static com.google.common.base.Preconditions.checkNotNull;

public class OGraphDBInitializer
{
    public void execute(String[] args) throws IOException {
        if(args[1]== "create" )
        {
            String db_name = args[2];

            OServerAdmin server = new OServerAdmin("remote:localhost").connect("admin","admin");
            server.createDatabase(db_name, "graph","local");
        }
    }
}
