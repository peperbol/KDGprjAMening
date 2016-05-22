using UnityEngine;
using System.Collections;

public static class PathsConfig
{

    private const string APIurl = "https://dl.dropboxusercontent.com/u/18025474/AMENINGAPI/";

    private const string imageDirectoryPath = "/Questions/Images/";
    private const string fileDirectoryPath = "/Questions/";
    private const string answeredListFile = "/anwered.json";
    public const string WWWFilePrefix = "file:///";

    public static string ImageDirectoryPath { get { return Application.persistentDataPath + imageDirectoryPath; } }
    public static string DocDirectoryPath { get { return Application.persistentDataPath + fileDirectoryPath; } }

    public static string AnsweredListFile { get { return Application.persistentDataPath + answeredListFile; } }
    public static string ImageLeftPath(string id, bool www = false) { return ((www) ? WWWFilePrefix : "") + ImageDirectoryPath + id + "L.jpg"; }
    public static string ImageRightPath(string id, bool www = false) { return ((www) ? WWWFilePrefix : "") + ImageDirectoryPath + id + "R.jpg"; }
    public static string ImageFullPath(string id, bool www = false) { return ((www) ? WWWFilePrefix : "") + ImageDirectoryPath + id + ".jpg"; }
    public static string DocPath(string id, bool www = false) { return ((www) ? WWWFilePrefix : "") + DocDirectoryPath + id + ".json"; }

    public static string JsonDirectoryUrl { get { return APIurl + "/questions/details/"; } }
    public static string JsonFileUrl(string id) { return JsonDirectoryUrl + id + ".json"; }

    public static string ImageDirectoryUrl { get { return APIurl + "/questions/getimage/"; } }
    public static string ImageLeftUrl(string id) { return ImageDirectoryUrl + id + "L.jpg"; }
    public static string ImageRightUrl(string id) { return ImageDirectoryUrl + id + "R.jpg"; }
    public static string ImageFullUrl(string id) { return ImageDirectoryUrl + id + ".jpg"; }
    public static string CurrentIdsUrl { get { return APIurl + "/questions/getlistall"; } }
    public static string CommentsUrl(string phaseId) { return APIurl + "/phases/getcomments/"+ phaseId+".json"; }
}
