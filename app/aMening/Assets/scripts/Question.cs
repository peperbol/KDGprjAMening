using UnityEngine;
using System.Collections;

public class Question
{
    public const string ImagePath = "";

    public string id { get; private set; }
    public string questionText { get; private set; }
    public string leftText { get; private set; }
    public string rightText { get; private set; }
    public string phase { get; private set; }

    public Question(string id)
    {

    }
    public Question(string id, string questionText, string leftText, string rightText, string phase)
    {
        this.id = id;
        this.questionText = questionText;
        this.leftText = leftText;
        this.rightText = rightText;
        this.phase = phase;
    }
    public void Save()
    {

    }
}
