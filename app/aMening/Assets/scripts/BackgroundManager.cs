using UnityEngine;
using System.Collections;

public class BackgroundManager : MonoBehaviour
{
    public GameObject NoAvailable;
    public GameObject Loading;
	
	public void UpdateBG () {
        bool l = GetComponent<DownloadQuestions>().DownloadsPending || GetComponent<SwipeInput>().HasQuestions || GetComponent<LoadQuestion>().QuestionsPending;
        Loading.SetActive(l);
        NoAvailable.SetActive(!l);
    }
}
