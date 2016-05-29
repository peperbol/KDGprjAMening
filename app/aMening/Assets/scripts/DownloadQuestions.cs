using UnityEngine;
using System.Collections;
using System.Linq;
using System.Collections.Generic;
using System.IO;
/// <summary>
/// download necesary data from the API
/// </summary>
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
        Directory.CreateDirectory(PathsConfig.DocDirectoryPath);
        Directory.CreateDirectory(PathsConfig.ImageDirectoryPath);
        for (int i = 0; i < ids.Count; i++)
        {
            WWW docWWW = new WWW(PathsConfig.JsonFileUrl(ids[i]));
            
            while (!docWWW.isDone)
            {
                yield return null;
            }
            File.WriteAllBytes(PathsConfig.DocPath(ids[i]), docWWW.bytes);

            if (new Question(ids[i], null).fullPicture)
            {
                WWW picWww = new WWW(PathsConfig.ImageFullUrl(ids[i]));
                while (!picWww.isDone)
                {
                    yield return null;
                }
                File.WriteAllBytes(PathsConfig.ImageFullPath(ids[i]), picWww.bytes);
            }
            else
            {


                WWW picLWww = new WWW(PathsConfig.ImageLeftUrl(ids[i]));
                while (!picLWww.isDone)
                {
                    yield return null;
                }
                File.WriteAllBytes(PathsConfig.ImageLeftPath(ids[i]), picLWww.bytes);

                WWW picRWww = new WWW(PathsConfig.ImageRightUrl(ids[i]));
                while (!picRWww.isDone)
                {
                    yield return null;
                }
                File.WriteAllBytes(PathsConfig.ImageRightPath(ids[i]), picRWww.bytes);
            }
            lq.Add(ids[i]);
        }
        DownloadsPending = false;
    }
}
