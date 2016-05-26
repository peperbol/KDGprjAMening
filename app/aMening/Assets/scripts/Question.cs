using UnityEngine;
using System.Collections;
using System.IO;
using System;
using System.Collections.Generic;

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
    public Comment[] comments { get; private set; }
    public void GetLeftImage (MonoBehaviour mb, Action<Texture2D> callback) { mb.StartCoroutine(LoadImage(PathsConfig.ImageLeftPath(id, true) , callback)); }
    public void GetRightImage(MonoBehaviour mb, Action<Texture2D> callback) { mb.StartCoroutine(LoadImage(PathsConfig.ImageRightPath(id, true), callback)); }
    public void GetMainImage (MonoBehaviour mb, Action<Texture2D> callback) { mb.StartCoroutine(LoadImage(PathsConfig.ImageFullPath(id, true) , callback)); }
    public void GetComments (MonoBehaviour mb, Action<Comment[]> callback)
    {
        mb.StartCoroutine( WaitForComments(callback));
    }
    public IEnumerator LoadImage(string path, Action<Texture2D> callback)
    {

        var www = new WWW(path);

        while (!www.isDone) { yield return null; }
        if (!string.IsNullOrEmpty(www.error))
        {
            Debug.LogWarning(www.error);
            throw new FileNotFoundException();
        }
        callback(www.textureNonReadable);
    }
    public IEnumerator WaitForComments(Action<Comment[]> callback)
    {
        while(comments== null) { yield return null; }
        callback(comments);
    }
    public IEnumerator LoadComments()
    {

        var www = new WWW(PathsConfig.CommentsUrl(phase));

        while (!www.isDone) { yield return null; }
        if (!string.IsNullOrEmpty(www.error))
        {
            Debug.LogWarning(www.error);
            Debug.LogWarning(PathsConfig.CommentsUrl(phase));
            throw new FileNotFoundException();
        }

        List<JSONObject> obj = JSONObject.Create(www.text).list;
        Comment[] comments = new Comment[obj.Count];
        for (int i = 0; i < obj.Count; i++)
        {

            string text = "";
            long time = 0;
            obj[i].GetField(ref text, "text");
            obj[i].GetField(ref time, "time");
            comments[i] = new Comment(text, UnixTimeStampToDateTime(time));
        }
        this.comments = comments;
    }
    public static DateTime UnixTimeStampToDateTime(long unixTimeStamp) // http://stackoverflow.com/questions/249760/how-to-convert-a-unix-timestamp-to-datetime-and-vice-versa
    {
        // Unix timestamp is seconds past epoch
        DateTime dtDateTime = new DateTime(1970, 1, 1, 0, 0, 0, 0, System.DateTimeKind.Utc);
        dtDateTime = dtDateTime.AddSeconds(unixTimeStamp).ToLocalTime();
        return dtDateTime;
    }
    public Question(string id, MonoBehaviour mb)
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
        var qObj = obj.list[1];
        string s = "";
        qObj.GetField(ref s, "questiontext");
        questionText = s;
        qObj.GetField(ref s, "leftlabel");
        leftText = s;
        qObj.GetField(ref s, "rightlabel");
        rightText = s;
        qObj.GetField(ref s, "project_phase_id");
        phase = s;
        obj.list[0].GetField(ref s, "name");
        projectText = s;
        qObj.GetField(ref s, "right_picture_path");
        fullPicture = string.IsNullOrEmpty( s);
        if(mb)
            mb.StartCoroutine(LoadComments());
    }

    public Question(string id, string questionText, string leftText, string rightText, string phase)
    {
        this.id = id;
        this.questionText = questionText;
        this.leftText = leftText;
        this.rightText = rightText;
        this.phase = phase;
    }
}
public struct Comment {
    public string text;
    public DateTime timeStamp;
    public Comment(string text, DateTime timeStamp) {
        this.text = text;
        this.timeStamp = timeStamp;
    }
}
