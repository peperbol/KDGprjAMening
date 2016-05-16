﻿using UnityEngine;
using System.Collections;
using System.IO;
using System;

public class Question
{
    public string FilePath { get { return PathsConfig.DocDirectoryPath + id + ".json"; } }

    public string id { get; private set; }
    public string questionText { get; private set; }
    public string projectText { get; private set; }
    public string leftText { get; private set; }
    public string rightText { get; private set; }
    public string phase { get; private set; }
    public bool fullPicture { get; private set; }
    public void GetLeftImage (MonoBehaviour mb, Action<Texture2D> callback) { mb.StartCoroutine(LoadImage(id + "L", callback)); }
    public void GetRightImage(MonoBehaviour mb, Action< Texture2D> callback) { mb.StartCoroutine(LoadImage(id + "R", callback)); }
    public void GetMainImage (MonoBehaviour mb, Action<Texture2D> callback) { mb.StartCoroutine(LoadImage(id, callback)); }

    public IEnumerator LoadImage(string name, Action<Texture2D> callback)
    {

        var www = new WWW(PathsConfig.WWWFilePrefix + PathsConfig.ImageDirectoryPath + name + ".jpg");

        while (!www.isDone) { yield return null; }
        if (!string.IsNullOrEmpty(www.error))
        {
            Debug.LogWarning(www.error);
            throw new FileNotFoundException();
        }
        callback(www.textureNonReadable);
    }
    public Question(string id)
    {

        this.id = id;
        //File.ReadAllText()
        var www = new WWW(PathsConfig.WWWFilePrefix + FilePath);
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
        obj.GetField(ref s, "project");
        projectText = s;
        bool b = false;
        obj.GetField(ref b, "fullpicture");
        fullPicture = b;
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
