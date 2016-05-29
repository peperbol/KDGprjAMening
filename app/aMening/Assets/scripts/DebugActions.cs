using UnityEngine;
using System.Collections;
using System.IO;
using UnityEngine.SceneManagement;


/// <summary>
///  handles the menus for debug purposes
/// </summary>
public class DebugActions : MonoBehaviour {
    public GameObject panel;
    public bool debugEnabled = true;
    public static bool loopQuestions = false;
	void Update () {
        if (Input.GetKeyDown(KeyCode.Escape) && debugEnabled) //backbutton in android
        {
            panel.SetActive(!panel.activeSelf);
        }
	}
    public void ClearAnswers()
    {
        File.Delete(PathsConfig.AnsweredListFile);
        SceneManager.LoadScene(SceneManager.GetActiveScene().name);
    }
    public void DeleteDownloadedData() {
        Directory.Delete(PathsConfig.ImageDirectoryPath, true);
        Directory.Delete(PathsConfig.DocDirectoryPath, true);
        SceneManager.LoadScene(SceneManager.GetActiveScene().name);
    }

    public void LoopQuestions()
    {
        panel.SetActive(false);
        loopQuestions = !loopQuestions;
    }
}
