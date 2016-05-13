using UnityEngine;
using System.Collections;
using System.Linq;
using System.Collections.Generic;
using System.IO;

public class DownloadQuestions : MonoBehaviour
{

    public void DownloadAndAdd(List<string> ids)
    {
        StartCoroutine(Download(ids));
    }
    public bool DownloadsPending { private set; get; }
    IEnumerator Download(List<string> ids)
    {
        DownloadsPending = true;
        LoadQuestion lq = FindObjectOfType<LoadQuestion>();
        Directory.CreateDirectory(PathsConfig.FileDirectoryPath);
        Directory.CreateDirectory(PathsConfig.ImageDirectoryPath);
        for (int i = 0; i < ids.Count; i++)
        {
            WWW docWWW = new WWW(PathsConfig.JsonUrl + ids[i] + ".json");
            while (!docWWW.isDone)
            {
                yield return null;
            }
            File.WriteAllBytes(PathsConfig.FileDirectoryPath + ids[i] + ".json", docWWW.bytes);

            if (new Question(ids[i]).fullPicture)
            {
                WWW picWww = new WWW(PathsConfig.ImageUrl + ids[i] + ".jpg");
                while (!picWww.isDone)
                {
                    yield return null;
                }
                File.WriteAllBytes(PathsConfig.ImageDirectoryPath + ids[i] + ".jpg", picWww.bytes);
            }
            else
            {

                WWW picLWww = new WWW(PathsConfig.ImageUrl + ids[i] + "L.jpg");
                while (!picLWww.isDone)
                {
                    yield return null;
                }
                File.WriteAllBytes(PathsConfig.ImageDirectoryPath + ids[i] + "L.jpg", picLWww.bytes);

                WWW picRWww = new WWW(PathsConfig.ImageUrl + ids[i] + "R.jpg");
                while (!picRWww.isDone)
                {
                    yield return null;
                }
                File.WriteAllBytes(PathsConfig.ImageDirectoryPath + ids[i] + "R.jpg", picRWww.bytes);
            }
            lq.Add(ids[i]);
        }
        DownloadsPending = false;
    }
}
