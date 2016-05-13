using UnityEngine;
using System.Collections;
using System.IO;
using UnityEngine.SceneManagement;

public class DebugActions : MonoBehaviour {
    public GameObject Panel;

    public static bool loopQuestions = false;
	void Update () {
        if (Input.GetKeyDown(KeyCode.Escape))
        {
            Panel.SetActive(!Panel.activeSelf);
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
        loopQuestions = !loopQuestions;
    }
}
