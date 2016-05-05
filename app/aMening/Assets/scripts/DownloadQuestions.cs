using UnityEngine;
using System.Collections;
using System.Linq;
using System.Collections.Generic;
using System.IO;

public class DownloadQuestions : MonoBehaviour {
    private const string url = "https://dl.dropboxusercontent.com/u/18025474/AMENINGAPI/";
    private static string idsUrl { get { return url + "/questions/getlistall"; } }
    private static string jsonUrl { get { return url + "/questions/details/"; } }
    private static string imageUrl { get { return url + "/questions/getimage/"; } }
    // Use this for initialization
    void Start() {
        StartCoroutine( CheckForDownloads());
    }
    IEnumerator CheckForDownloads() {
        WWW idsWww = new WWW(idsUrl);
        while (!idsWww.isDone)
        {
            yield return null;
        }
        var obj = JSONObject.Create(idsWww.text);
        List<string> ids = obj.GetField("ids").list.ConvertAll(e=>e.str);
        LoadQuestion lq = FindObjectOfType<LoadQuestion>();
        Directory.CreateDirectory(Question.FileDirectoryPath);
        Directory.CreateDirectory(Question.ImageDirectoryPath);
        for (int i = 0; i < ids.Count; i++)
        {
            WWW docWWW = new WWW(jsonUrl+ ids[i] + ".json");
            while (!docWWW.isDone)
            {
                yield return null;
            }
            File.WriteAllBytes(Question.FileDirectoryPath + ids[i] + ".json", docWWW.bytes);

            if(new Question(ids[i]).fullPicture)
            {
                WWW picWww = new WWW(imageUrl + ids[i] + ".jpg");
                while (!picWww.isDone)
                {
                    yield return null;
                }
                File.WriteAllBytes(Question.ImageDirectoryPath + ids[i] + ".jpg", picWww.bytes);
            }
            else
            {

                WWW picLWww = new WWW(imageUrl + ids[i] + "L.jpg");
                while (!picLWww.isDone)
                {
                    yield return null;
                }
                File.WriteAllBytes(Question.ImageDirectoryPath + ids[i] + "L.jpg", picLWww.bytes);

                WWW picRWww = new WWW(imageUrl + ids[i] + "R.jpg");
                while (!picRWww.isDone)
                {
                    yield return null;
                }
                File.WriteAllBytes(Question.ImageDirectoryPath + ids[i] + "R.jpg", picRWww.bytes);
            }
            lq.Add(ids[i]);
        }
    }
	void Update () {
	
	}
}
