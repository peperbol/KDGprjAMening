using UnityEngine;
using System.Collections;
using System.Collections.Generic;
using System.IO;
using System.Linq;

public class ToDoHandler : MonoBehaviour
{


    void Start()
    {
        StartCoroutine(FetchIDs());
    }

    List<string> CurrentQuestions;
    List<string> AnsweredQuestions;
    List<string> DownloadedQuestions;

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

        if (obj.GetField("ids") != null)
            CurrentQuestions = obj.GetField("ids").list.ConvertAll(e => e.str);
        else
            CurrentQuestions = new List<string>();
        isGetCurrentQuestionsRunning = false;
    }

    IEnumerator GetAnsweredQuestions()
    {
        isGetAnsweredQuestionsRunning = true;
        WWW idsWww = new WWW(PathsConfig.WWWFilePrefix+PathsConfig.AnsweredListFile);
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
        if (Directory.Exists(PathsConfig.FileDirectoryPath) && Directory.Exists(PathsConfig.ImageDirectoryPath))
        {
            DownloadedQuestions = Directory.GetFiles(PathsConfig.FileDirectoryPath).ToList().ConvertAll(e => e.Substring(0, e.IndexOf(".json")).Substring(e.LastIndexOf("/") + 1));

            DownloadedQuestions = DownloadedQuestions.Where(e => (new Question(e).fullPicture) ? File.Exists(PathsConfig.ImageDirectoryPath+e+ ".jpg"):  File.Exists(PathsConfig.ImageDirectoryPath + e + "L.jpg") && File.Exists(PathsConfig.ImageDirectoryPath + e + "R.jpg")).ToList();
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

    }
}
