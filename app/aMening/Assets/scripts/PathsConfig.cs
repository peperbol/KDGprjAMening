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
    public static string AnsweredListFile { get { return Application.persistentDataPath + answeredListFile; } }
    public static string FileDirectoryPath { get { return Application.persistentDataPath + fileDirectoryPath; } }

    public static string JsonUrl { get { return APIurl + "/questions/details/"; } }
    public static string ImageUrl { get { return APIurl + "/questions/getimage/"; } }
    public static string CurrentIdsUrl { get { return APIurl + "/questions/getlistall"; } }
}
