using UnityEngine;
using System.Collections;
using System.Collections.Generic;
using System.IO;
using System.Linq;

public class ToDoHandler : MonoBehaviour
{


    public void Start()
    {
        StartCoroutine(FetchIDs());
        Debug.Log("start");
    }

    List<string> CurrentQuestions;
    List<string> AnsweredQuestions;
    List<string> DownloadedQuestions;
    public bool HasEverAnswered { get { return AnsweredQuestions.Count > 0; } }
    IEnumerator FetchIDs()
    {
        StartCoroutine(GetCurrentQuestions());
        StartCoroutine(GetAnsweredQuestions());
        StartCoroutine(GetDownloadedQuestions());

        while (isGetCurrentQuestionsRunning || isGetAnsweredQuestionsRunning || isGetDownloadedQuestionsRunning)
        {
            yield return null;
        }

        Debug.Log("curr");
        foreach (var item in CurrentQuestions)
        {
            Debug.Log(item);
        }
        Debug.Log("answ");
        foreach (var item in AnsweredQuestions)
        {
            Debug.Log(item);
        }
        Debug.Log("dl");
        foreach (var item in DownloadedQuestions)
        {
            Debug.Log(item);
        }

        FindObjectOfType<DownloadQuestions>().DownloadAndAdd(CurrentQuestions.Where(e => !AnsweredQuestions.Contains(e) && !DownloadedQuestions.Contains(e)).ToList());
        var toAdd = CurrentQuestions.Where(e => !AnsweredQuestions.Contains(e) && DownloadedQuestions.Contains(e));

        LoadQuestion lq = FindObjectOfType<LoadQuestion>();
        foreach (var item in toAdd)
        {
            lq.Add(item);
        }

        FindObjectOfType<BackgroundManager>().UpdateBackGround();

    }

    bool isGetCurrentQuestionsRunning = false;
    bool isGetAnsweredQuestionsRunning = false;
    bool isGetDownloadedQuestionsRunning = false;

    IEnumerator GetCurrentQuestions()
    {
        isGetCurrentQuestionsRunning = true;
        WWW idsWww = new WWW(PathsConfig.CurrentIdsUrl);
        while (!idsWww.isDone)
        {
            yield return null;
        }
        var obj = JSONObject.Create(idsWww.text);

        if (obj.list != null)
            CurrentQuestions = obj.list.ConvertAll(e => e.i.ToString());
        else
            CurrentQuestions = new List<string>();
        isGetCurrentQuestionsRunning = false;
    }

    IEnumerator GetAnsweredQuestions()
    {
        isGetAnsweredQuestionsRunning = true;
        WWW idsWww = new WWW(PathsConfig.WWWFilePrefix + PathsConfig.AnsweredListFile);
        while (!idsWww.isDone)
        {
            yield return null;
        }
        var obj = JSONObject.Create(idsWww.text);
        if (obj.GetField("ids") != null)
            AnsweredQuestions = obj.GetField("ids").list.ConvertAll(e => e.str);
        else
            AnsweredQuestions = new List<string>();
        isGetAnsweredQuestionsRunning = false;
    }

    IEnumerator GetDownloadedQuestions()
    {
        isGetDownloadedQuestionsRunning = true;
        if (Directory.Exists(PathsConfig.DocDirectoryPath) && Directory.Exists(PathsConfig.ImageDirectoryPath))
        {
            //get ids
            DownloadedQuestions = Directory.GetFiles(PathsConfig.DocDirectoryPath).ToList().ConvertAll(e => e.Substring(0, e.IndexOf(".json")).Substring(e.LastIndexOf("/") + 1));
            //filter if images exist
            DownloadedQuestions = DownloadedQuestions.Where(e => (new Question(e, null).fullPicture) ? File.Exists(PathsConfig.ImageFullPath(e)) : File.Exists(PathsConfig.ImageLeftPath(e)) && File.Exists(PathsConfig.ImageRightPath(e))).ToList();
        }
        else
        {
            DownloadedQuestions = new List<string>();
        }
        isGetDownloadedQuestionsRunning = false;
        yield return null;
    }

    public void AddAnswered(string id)
    {
        AnsweredQuestions.Add(id);

        var obj = JSONObject.Create();
        obj.AddField("ids", JSONObject.Create(JSONObject.Type.ARRAY));
        foreach (var item in AnsweredQuestions)
        {
            obj.GetField("ids").Add(item);
        }

        File.WriteAllText(PathsConfig.AnsweredListFile, obj.ToString());
        DeleteData(id);
    }
    void DeleteData(string id)
    {

        File.Delete(PathsConfig.ImageLeftPath(id));
        File.Delete(PathsConfig.ImageRightPath(id));
        File.Delete(PathsConfig.ImageFullPath(id));
        File.Delete(PathsConfig.DocPath(id));
    }
}
