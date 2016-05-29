using UnityEngine;
using System.Collections;

public class BackgroundManager : MonoBehaviour
{
    public GameObject noAvailable;
    public GameObject loading;
    bool lastResult;
	public void UpdateBackGround () {

        bool loading = GetComponent<DownloadQuestions>().DownloadsPending || GetComponent<SwipeInput>().HasQuestions || GetComponent<LoadQuestion>().QuestionsPending;
        this.loading.SetActive(loading);
        noAvailable.SetActive(!loading);
        if (!loading) {
            GetComponent<LoadQuestion>().RemoveBootupScreen(null);
            //Debug.Log("noquestions");
        }
        lastResult = loading;
    }
}
