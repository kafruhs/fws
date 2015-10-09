<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 11.03.2015
 * Time: 08:16
 */

class base_infrastructure_Folder
{
    const DELETE_FOLDER_SUCCESS = 0;

    const DELETE_FOLDER_NOFOLDER = 1;

    const DELETE_FOLDER_ERROR = 2;

    const DELETE_FOLDER_NOFOLDERORFILE = 3;


    public static function getFilesFromFolder($folderPathRelativeToROOT)
    {
        $fileNameList = [];
        $handle = opendir(ROOT . '/' . $folderPathRelativeToROOT);
        while($fileName = readdir($handle)) {
            if ($fileName != '.' && $fileName != '..' && $fileName != '.svn') {
                $fileNameList[] = $fileName;
            }
        }
        return $fileNameList;
    }


    /**
     * rec_rmdir - loesche ein Verzeichnis rekursiv
     * Rueckgabewerte:
     * 0  - alles ok
     * -1 - kein Verzeichnis
     * -2 - Fehler beim Loeschen
     * -3 - Ein Eintrag eines Verzeichnisses war keine Datei und kein Verzeichnis und
     * kein Link
     */
    public static function rmdirRecursive ($path) {
        // schau' nach, ob das ueberhaupt ein Verzeichnis ist
        if (!is_dir ($path)) {
            return self::DELETE_FOLDER_NOFOLDER;
        }
        // oeffne das Verzeichnis
        $dir = @opendir ($path);

        // Fehler?
        if (!$dir) {
            return self::DELETE_FOLDER_ERROR;
        }

        // gehe durch das Verzeichnis
        while (($entry = @readdir($dir)) !== false) {
            // wenn der Eintrag das aktuelle Verzeichnis oder das Elternverzeichnis
            // ist, ignoriere es
            if ($entry == '.' || $entry == '..') {
                continue;
            }
            // wenn der Eintrag ein Verzeichnis ist, dann
            if (is_dir($path.'/'.$entry)) {
                // rufe mich selbst auf
                $res = self::rmdirRecursive ($path.'/'.$entry);
                // wenn ein Fehler aufgetreten ist
                if ($res == self::DELETE_FOLDER_NOFOLDER) { // dies duerfte gar nicht passieren
                    @closedir ($dir); // Verzeichnis schliessen
                    return self::DELETE_FOLDER_ERROR; // normalen Fehler melden
                } else if ($res == self::DELETE_FOLDER_ERROR) { // Fehler?
                    @closedir ($dir); // Verzeichnis schliessen
                    return self::DELETE_FOLDER_ERROR; // Fehler weitergeben
                } else if ($res == self::DELETE_FOLDER_NOFOLDERORFILE) { // nicht unterstuetzer Dateityp?
                    @closedir ($dir); // Verzeichnis schliessen
                    return self::DELETE_FOLDER_NOFOLDERORFILE; // Fehler weitergeben
                } else if ($res != self::DELETE_FOLDER_SUCCESS) { // das duerfe auch nicht passieren...
                    @closedir ($dir); // Verzeichnis schliessen
                    return self::DELETE_FOLDER_ERROR; // Fehler zurueck
                }
            } else if (is_file ($path.'/'.$entry) || is_link ($path.'/'.$entry)) {
                // ansonsten loesche diese Datei / diesen Link
                $res = @unlink ($path.'/'.$entry);
                // Fehler?
                if (!$res) {
                    @closedir ($dir); // Verzeichnis schliessen
                    return self::DELETE_FOLDER_ERROR; // melde ihn
                }
            } else {
                // ein nicht unterstuetzer Dateityp
                @closedir ($dir); // Verzeichnis schliessen
                return self::DELETE_FOLDER_NOFOLDERORFILE; // tut mir schrecklich leid...
            }
        }

        // schliesse nun das Verzeichnis
        @closedir ($dir);

        // versuche nun, das Verzeichnis zu loeschen
        $res = @rmdir ($path);

        // gab's einen Fehler?
        if (!$res) {
            return self::DELETE_FOLDER_ERROR; // melde ihn
        }

        // alles ok
        return self::DELETE_FOLDER_SUCCESS;
    }
}
