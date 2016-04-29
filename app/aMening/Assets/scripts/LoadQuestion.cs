using UnityEngine;
using System.Collections;
using UnityEngine.UI;
using System.Collections.Generic;
using System.Linq;

public class LoadQuestion : MonoBehaviour {

    public Text questionText;
    public Queue<Question> questions = new Queue<Question>();
    public Material Image;
    public List<string> ids;
    public Question lastQuestion;
    void Start () {
        QueueIds();
    }
    void QueueIds() {
        foreach (var id in ids)
        {
            try
            {
                questions.Enqueue(new Question(id));
            }
            catch (System.IO.FileNotFoundException) { Debug.LogWarning("Did not find file of id " + id); }
        }
        ids.Clear();
    }

    public void NextQuestion( Text left, Text right) {
        if (questions.Count <= 0) return;
        lastQuestion = questions.Dequeue();
        left.text = lastQuestion.leftText;
        right.text = lastQuestion.rightText;
    }
    public void SetTitle() {

        questionText.text = lastQuestion.questionText;
    }

	void Update () {
	
	}
}
