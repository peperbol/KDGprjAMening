﻿using UnityEngine;
using System.Collections;
using System.IO;
using System;

public class Question
{
    private const string imageDirectoryPath = "Questions/Images";
    private const string fileDirectoryPath = "Questions/";
    public static string ImageDirectoryPath
    {
        get
        {
            if (Application.isMobilePlatform)
                return "jar:file://" + Application.dataPath + "!/assets/" + imageDirectoryPath;
            else
                return ("file:///" + Application.dataPath + "/StreamingAssets/" + imageDirectoryPath).Replace(" ", "%20");
            return Application.persistentDataPath + imageDirectoryPath;
        }
    }
    public static string FileDirectoryPath
    {
        get
        {
            if (Application.isMobilePlatform)
                return "jar:file://" + Application.dataPath + "!/assets/" + fileDirectoryPath;
            else
                return ("file:///" + Application.dataPath + "/StreamingAssets/" + fileDirectoryPath).Replace(" ", "%20");
            return Application.persistentDataPath + fileDirectoryPath;
        }
    }
    public string FilePath { get { return FileDirectoryPath + id + ".json"; } }
    public string ImagePath { get { return ImageDirectoryPath + id + ".jpg"; } }

    public string id { get; private set; }
    public string questionText { get; private set; }
    public string leftText { get; private set; }
    public string rightText { get; private set; }
    public string phase { get; private set; }
    public Texture2D LeftImage { get { throw new System.NotImplementedException(); } }
    public Texture2D RightImage { get { throw new System.NotImplementedException(); } }

    public Question(string id)
    {

        this.id = id;
        //File.ReadAllText()
        var www = new WWW(FilePath);
        while (!www.isDone) { };
        if (!string.IsNullOrEmpty(www.error))
        {
            Debug.LogWarning(www.error);
            throw new FileNotFoundException();
        }
        var obj = JSONObject.Create(www.text);

        string s = "";
        obj.GetField(ref s, "question");
        questionText = s;
        obj.GetField(ref s, "leftlabel");
        leftText = s;
        obj.GetField(ref s, "rightlabel");
        rightText = s;
        obj.GetField(ref s, "phase");
        phase = s;
    }

    public Question(string id, string questionText, string leftText, string rightText, string phase)
    {
        this.id = id;
        this.questionText = questionText;
        this.leftText = leftText;
        this.rightText = rightText;
        this.phase = phase;
    }
    public void Save()
    {

    }
}
