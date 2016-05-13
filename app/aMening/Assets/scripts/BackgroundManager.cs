using UnityEngine;
using System.Collections;

public class BackgroundManager : MonoBehaviour
{
    public GameObject NoAvailable;
    public GameObject Loading;
    bool lastResult;
	public void UpdateBG () {
        bool loading = GetComponent<DownloadQuestions>().DownloadsPending || GetComponent<SwipeInput>().HasQuestions || GetComponent<LoadQuestion>().QuestionsPending;
        Loading.SetActive(loading);
        NoAvailable.SetActive(!loading);
        if (!loading) {
            GetComponent<LoadQuestion>().removeBootupScreen();
            Debug.Log("noquestions");
        }
        lastResult = loading;
    }
}
